import {Job} from "./job";
import {Item} from "./item";

export class PlayerJob {
  id: number;
  isMain: boolean;
  isSub: boolean;
  job: Job;
  ord: number;
  head: boolean;
  body: boolean;
  hand: boolean;
  belt: boolean;
  leg: boolean;
  feet: boolean;
  neck: boolean;
  earring: boolean;
  bracelet: boolean;
  ring1: boolean;
  ring2: boolean;
  wishHead : Item;
  wishBody : Item;
  wishHand : Item;
  wishLeg : Item;
  wishFeet : Item;
  wishWaist : Item;
  wishEarring : Item;
  wishBracelet : Item;
  wishRing1 : Item;
  wishRing2 : Item;
  wishNeck : Item;
}
