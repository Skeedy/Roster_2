import { Injectable } from '@angular/core';
import { PlayerList } from '../class/player-list';
import {HttpClient} from '@angular/common/http';
import {Result} from "../class/result";
import {Globals} from "../globals";


@Injectable({
  providedIn: 'root'
})
export class PlayerListService {
public playerList: PlayerList;
public nbPlayer: number;
public formUp :boolean;
public nbForm = 0;
  constructor(private http: HttpClient) {
    this.playerList = new PlayerList();
  }
  addPlayer(result: Result){
    this.playerList.addPlayer(result);
    this.formUp = true;
  }
  removePlayer(result){
    this.playerList.removePlayer(result);
    this.formUp = false;
  }
  searchPlayer(fname, lname, server) {
    return this.http.get('https://xivapi.com/character/search?name='+fname+'+'+lname+'&server='+server)
  }
  postPlayer(){
    return this.http.post(Globals.APP_API + '/player/new', this.playerList);
  }
}
