<?php

namespace app\classes;

use InvalidArgumentException;

class TablePath
{
  private ?string $path;

  public function __construct(?array $path)
  {
    $this->path = self::validatePath($path);
  }

  private function validatePath(?array $path): string
  {
    if (pathinfo($path['name'], PATHINFO_EXTENSION) != 'xlsx') {
      throw new InvalidArgumentException('Arquivo nao e xlsx: ' . $path['name']);
    }
    return $path['tmp_name'];
  }

  public function __toString(): string
  {
    return $this->path;
  }
}
