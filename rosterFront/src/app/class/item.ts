import {Slot} from "./slot";

export class Item {
  id: number;
  name: string;
  ilvl: number;
  imgUrl: string;
  LodId: number;
  isSavage: boolean;
  slot: Slot;
  jobType: string;
}
