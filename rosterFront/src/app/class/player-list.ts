import { Result} from "./result";

export class PlayerList {
  player: Result[];
  constructor() {
    this.player = [];
  }
  addPlayer(player: Result){
    this.player.push(player);
    console.log(this.player);
  }
}
