<?php

namespace Cookly\Models;

class Recipe
{
  private int $id;
  private int $user_id;
  private string $user_name;
  private string $name;
  private string $details;
  private bool $public;
  private float $stars;

  public function __construct(
    int    $id,
    int    $user_id,
    string $user_name,
    string $name,
    string $details,
    bool   $public,
    float  $stars
  )
  {
    $this->id = $id;
    $this->user_id = $user_id;
    $this->user_name = $user_name;
    $this->name = $name;
    $this->details = $details;
    $this->public = $public;
    $this->stars = $stars;
  }

  public function getStars(): float
  {
    return $this->stars;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getDetails(): string
  {
    return $this->details;
  }

  public function getUserName(): string
  {
    return $this->user_name;
  }

  public function getUserId(): int
  {
    return $this->user_id;
  }

  public function isPublic(): bool
  {
    return $this->public;
  }
}
