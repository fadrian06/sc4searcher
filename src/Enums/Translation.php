<?php

namespace SC4S\Enums;

enum Translation: string
{
  case ENGLISH = 'en';
  case SPANISH = 'es';

  function translatedName(self $chosenTraslation): string
  {
    if ($chosenTraslation === self::SPANISH) {
      return $this === self::ENGLISH ? 'Inglés' : 'Español';
    }

    return mb_convert_case($this->name, MB_CASE_TITLE);
  }
}
