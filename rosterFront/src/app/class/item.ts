import {Slot} from "./slot";
import {Job} from "./job";

export class Item {
  id: number;
  name: string;
  ilvl: number;
  imgUrl: string;
  LodId: number;
  isSavage: boolean;
  slot: Slot;
  jobType: string;
  jobs: Job[];
  isCoffer: boolean;
  isUpgrade: boolean;
  isUpgraded: boolean;
}
