<?php

function AJVAbilityType($cardID, $index = -1, $from = "-"): string
{
  return match ($cardID) {
    //"AJV00X" => "A",  // TODO: Add Jarl's equipment once they are revealed.
    default => ""
  };
}

function AJVAbilityHasGoAgain($cardID): bool
{
  return match ($cardID) {
    //"AJV00X"  => true, // TODO: Add Jarl's equipment once they are revealed.
    default => false
  };
}

function AJVCombatEffectActive($cardID, $attackID): bool
{
  return match ($cardID) {
    default => false
  };
}

function AJVAbilityCost($cardID): int
{
  return match ($cardID) {
    //"AJV00X"  => 1, // TODO: Add Jarl's equipment once they are revealed.
    default => 0
  };
}
      case "DYN114":
        if (ContractType($cardID) != "") AddLayer("TRIGGER", $currentPlayer, $characterID);
        break;

// Preemptively adding AJV effect attack modifier since I assume this will be relevant for new Jarl cards in the armory deck. TODO: Add the relevant Jarl cards when they are revealed.
function AJVEffectAttackModifier($cardID): int
{
    global $currentPlayer;

    return match ($cardID) {
    //"AJV00X" => SearchCurrentTurnEffects("AJV00X", $currentPlayer) ? 1 : 2, // Example of modifier that itself is modified if another effect is active.
    //"AJV00X", "AJV00X", "AJV00X", "AJV00X" => 1,
    default => 0
    };
}
case "WTR057": case "WTR058": case "WTR059":
    AddDecisionQueue("FINDINDICES", $defPlayer, "EQUIP");
    AddDecisionQueue("CHOOSETHEIRCHARACTER", $mainPlayer, "<-", 1);
    AddDecisionQueue("MODDEFCOUNTER", $defPlayer, "-1", 1);
    break;

function AJVProcessJarlFreeze():
{
    $weapons = "";
    $char = &GetPlayerCharacter($mainPlayer);
    $otherPlayer = $currentPlayer == 1 ? 2 : 1;
    $inventory = &GetInventory($mainPlayer);
    if ($char[CharacterPieces() + 1] == 0 || $char[CharacterPieces() * 2 + 1] == 0) { //Only Equip if there is a broken weapon/off-hand
      foreach ($inventory as $cardID) {
        if (TypeContains($cardID, "W", $mainPlayer) && SubtypeContains($cardID, "Dagger")) {
          if ($weapons != "") $weapons .= ",";
          $weapons .= $cardID;
        };
      }
      if ($weapons == "") {
        WriteLog("Player " . $mainPlayer . " doesn't have any dagger in their inventory");
        return;
      }
      AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose a dagger to equip");
      AddDecisionQueue("CHOOSECARD", $mainPlayer, $weapons);
      AddDecisionQueue("APPENDLASTRESULT", $mainPlayer, "-INVENTORY");
      AddDecisionQueue("EQUIPCARD", $mainPlayer, "<-");
    }
    break;
    .....................    
    AddDecisionQueue("FINDINDICES", $defPlayer, "EQUIP");
    AddDecisionQueue("CHOOSETHEIRCHARACTER", $mainPlayer, "<-", 1);
    AddDecisionQueue("MODDEFCOUNTER", $defPlayer, "-1", 1);
    break;
}

function AJVPlayAbility($cardID, $from, $resourcesPaid, $target = "-", $additionalCosts = ""): string
{
  global $currentPlayer, $CS_PlayIndex;
  switch ($cardID) {
    case "AIO006":
      $deck = new Deck($currentPlayer);
      for($i = 0; $i < 2 && !$deck->Empty(); ++$i) {
        $banished = $deck->BanishTop();
        if(ClassContains($banished, "MECHANOLOGIST", $currentPlayer)) GainActionPoints(1, $currentPlayer);
      }
      return "";
    case "AIO004":
      AddCurrentTurnEffect($cardID, $currentPlayer);
      return "";
    case "AIO026":
      if ($from == "PLAY") {
        Draw($currentPlayer);
      }
      return "";
    default:
      return "";
  }
}