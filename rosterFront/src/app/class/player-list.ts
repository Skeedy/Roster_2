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
  removePlayer(index: string){
    let playerIndex = this.player.findIndex(index);
    console.log(playerIndex);
      }
}
