<?php

namespace Cookly\Repositories;

use Cookly\Models\User;

class UserRepository extends Repository
{
  public function getUser(int $id): ?User
  {
    $stmt = $this->db->prepare('SELECT * FROM user_view AS uv WHERE uv.id = :id LIMIT 1');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$user) {
      return null;
    }

    $role_id = $user['role_id'];
    $perms = $this->getUserPermissions($role_id);

    return new User(
      $user['id'],
      $user['name'],
      $user['email'],
      $role_id,
      $user['role_name'],
      $perms
    );
  }

  public function getUserPermissions(int $role_id): ?array
  {
    $stmt = $this->db->prepare('SELECT p.name FROM public.permission AS p JOIN role_permission rp on p.id = rp.permission_id WHERE rp.role_id = :role_id');
    $stmt->bindParam(':role_id', $role_id);
    $stmt->execute();

    $perms = $stmt->fetchAll(\PDO::FETCH_COLUMN);

    if (!$perms) {
      return null;
    }

    return $perms;
  }

  public function authenticate(
    string $email,
    string $password
  ): ?int
  {
    $stmt = $this->db->prepare('SELECT u.id, (u.password = crypt(:password, u.password)) AS authenticated FROM public."user" as u WHERE u.email = :email LIMIT 1;');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    if (!$user) {
      return null;
    }

    $user_id = $user['id'];
    $authenticated = $user['authenticated'];

    if (!$authenticated) {
      return null;
    }

    return $user_id;
  }

  public function createUser(
    string $name,
    string $email,
    string $password
  ): ?int
  {
    $this->db->beginTransaction();

    try {
      $stmt = $this->db->prepare('SELECT role.id FROM public.role WHERE role.is_default = TRUE LIMIT 1');
      $stmt->execute();

      $role = $stmt->fetch(\PDO::FETCH_ASSOC);

      if (!$role) {
        $this->db->rollBack();
        return null;
      }

      $role_id = $role['id'];

      $stmt = $this->db->prepare('INSERT INTO public."user" (email, password) VALUES (:email, crypt(:password, gen_salt(\'bf\'))) RETURNING id');
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $password);
      $stmt->execute();

      $user_id = $stmt->fetchColumn();

      if (!$user_id) {
        $this->db->rollBack();
        return null;
      }

      $stmt = $this->db->prepare('INSERT INTO public.user_data (user_id, role_id, name) VALUES (:user_id, :role_id, :name)');
      $stmt->bindParam(':user_id', $user_id);
      $stmt->bindParam(':role_id', $role_id);
      $stmt->bindParam(':name', $name);
      $stmt->execute();

      $this->db->commit();
      return $user_id;
    } catch (\PDOException $e) {
      $this->db->rollBack();
    }
    return null;
  }
}
