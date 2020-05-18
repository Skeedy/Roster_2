import { PlayerJob } from "./player-job";

export class Player {
  id: number;
  name: string;
  server: string;
  LodId : number;
  playerJobs : PlayerJob[];
  imgUrl : string
}
