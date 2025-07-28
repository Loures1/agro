<?php

namespace core\uri;

use core\uri\exceptions\InvalidUri;

class Uri
{
  static public function validade(Server $uri): Server
  {
    if (preg_match("/[^a-zA-Z0-9\/:%\[\],]/", $uri->value()) == true) {
      throw new InvalidUri(
        "Url Invalida. Caraceteres maisculos e especiais nao sao permitidos"
      );
    }

    if (
      preg_match('/\/{2,}/', $uri->value()) != false
      || preg_match_all('/\/\w*/', $uri->value()) > 3
      || $uri->value() == null
    ) {
      throw new InvalidUri(
        "Url Invalida. Formato invalido"
      );
    }
    return $uri;
  }
}
