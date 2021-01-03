import { PlayerJob } from "./player-job";
import {Loot} from "./loot";

export class Player {
  id: number;
  name: string;
  server: string;
  LodId : number;
  playerJobs : PlayerJob[];
  imgUrl : string
  portrait: string;
  loots: Loot[];
}
