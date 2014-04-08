<?php

/*
#############################################################################
#  Filename: artifacts.mo
#  Project: SuperNova.WS
#  Website: http://www.supernova.ws
#  Description: Massive Multiplayer Online Browser Space Startegy Game
#
#  Copyright © 2009 Gorlum for Project "SuperNova.WS"
#############################################################################
*/

/**
*
* @package language
* @system [Russian]
* @version 39a2.6
*
*/

/**
* DO NOT CHANGE
*/

if (!defined('INSIDE')) die();

//$lang = array_merge($lang,
//$lang->merge(
$a_lang_array = (array(
  'art_use'             => 'Использовать артефакт',

  'art_lhc_from'          => 'Большой Адронный Коллайдер',
  'art_lhc_subj'          => 'Попытка создания луны',
  'art_moon_create'   => array(
    ART_LHC => 'Гравитационная волна, запущенная БАК, соединила огромные куски металла и кристалла на орбите, в результате чего по образовалась новая луна %s по координатам %s!',
    ART_HOOK_SMALL => 'Малый Крюк запустил луну %1$s диаметром %3$s километров по координатам %2$s!',
    ART_HOOK_MEDIUM => 'Средний Крюк запустил луну %1$s диаметром %3$s километров по координатам %2$s!',
    ART_HOOK_LARGE => 'Большой Крюк запустил луну %1$s диаметром %3$s километров по координатам %2$s!',
  ),
  'art_moon_exists'   => 'На лунной орбите по текущим координатам уже находится луна',
  'art_lhc_moon_fail'     => 'Гравитационой волны БАК оказалось недостаточно для образования новой луны',

  'art_rcd_from'          => 'Автономный Колонизационный Комплекc',
  'art_rcd_subj'          => 'Колония развернута',
  'art_rcd_ok'            => '%1$s успешно развернул колонию на планете %2$s по координатам %3$s',
  'art_rcd_err_moon'      => 'АКК может быть развернут только на планете',
  'art_rcd_err_no_sense'  => 'АКК определил, что ни одно из зданий не будет усовершенствовано и прекратил развертывание',
  'art_rcd_err_que'       => 'АКК не может быть развернут на планете, где ведется строительство. Отмените всё строительство на планете и попробуйте развернуть АКК еще раз',

  'art_heurestic_chip_ok' => 'Время исследования технологии "%s" (уровень %d) уменьшено на %s',
  'art_heurestic_chip_subj' => 'Ускорение времени исследования',
  'art_heurestic_chip_no_research' => 'В настоящее время не ведется никаких исследований',

  'art_nano_builder_ok' => 'Время %s здания "%s" (уровень %d) на планете %s %s уменьшено на %s',
  'art_nano_builder_build' => 'строительства',
  'art_nano_builder_destroy' => 'сноса',
  'art_nano_builder_subj' => 'Ускорение строительной операции',
  'art_nano_builder_no_que' => 'В настоящее время на планете не производится строительных операций',

  'art_err_no_artifact'  => 'У вас нет нужного артефакта',

  'art_page_hint'        => '<ul>
    <li>Артефакты - редкие объекты с уникальными свойствами</li>
    <li>Артефакты являются одноразовыми - после использования Артефакт исчезает</li>
    <li>Некоторые Артефакты настолько мощные, что их количество в одной Империи не может быть больше опредленного числа</li>
    <li>Обычно эффект от использования Артефакта распространяется на планету применения, но некоторые Артефакты имеют всеимперский эффект.
    Самые редкие и дорогие Артефакты могут действовать на всю солнечную систему, галактику или даже на всю Вселенную!</li>
  </ul>',
));
