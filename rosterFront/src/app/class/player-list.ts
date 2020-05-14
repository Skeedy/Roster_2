export class PlayerList {
  playersIds : number[];
  rosterID: number;
  constructor() {
    this.playersIds = [];
  }
  addPlayer(id){
    this.playersIds.push(id);
    console.log(this.playersIds);
  }
  removePlayer(index){
    let playerIndex = this.playersIds.indexOf(index);
    this.playersIds.splice(playerIndex, 1);
    console.log(this.playersIds);
      }
}
