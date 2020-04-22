import { Injectable } from '@angular/core';
import { PlayerList } from '../class/player-list';
import {HttpClient} from '@angular/common/http';
import {Result} from "../class/result";


@Injectable({
  providedIn: 'root'
})
export class PlayerListService {
public playerList: PlayerList;
  constructor(private http: HttpClient) {
    this.playerList = new PlayerList();
  }
  addPlayer(result: Result){
    this.playerList.addPlayer(result)
  }
  removePlayer(result){
    this.playerList.removePlayer(result);
  }
  searchPlayer(fname, lname, server) {
    return this.http.get('https://xivapi.com/character/search?name='+fname+'+'+lname+'&server='+server)
  }
}
