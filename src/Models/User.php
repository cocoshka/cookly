<?php

namespace Cookly\Models;

class User
{
  private int $id;
  private string $name;
  private string $email;
  private int $role_id;
  private string $role_name;
  private array $permissions;

  public function __construct(
    int    $id,
    string $name,
    string $email,
    int    $role_id,
    string $role_name,
    array  $permissions
  )
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->role_id = $role_id;
    $this->role_name = $role_name;
    $this->permissions = $permissions;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getRoleId(): int
  {
    return $this->role_id;
  }

  public function getRoleName(): string
  {
    return $this->role_name;
  }

  public function getPermissions(): array
  {
    return $this->permissions;
  }
}
