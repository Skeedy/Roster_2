import { Injectable } from '@angular/core';
import { PlayerList } from '../class/player-list';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Result} from "../class/result";
import {Globals} from "../globals";
import {Player} from "../class/player";
import {Observable, of} from "rxjs";
import {tap, catchError} from "rxjs/operators";


@Injectable({
  providedIn: 'root'
})
export class PlayerListService {
public playerList: PlayerList;
public isSubmitted = false;
public isDone = false;
public formUp :boolean;
public nbForm :number;
  constructor(private http: HttpClient) {
    this.playerList = new PlayerList();
  }
  private log(log: string) {
    // tslint:disable-next-line:no-console
    console.info(log);
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

  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.log(error);
      console.log(`${operation} failed: ${error.message}`);
      return of(result as T);
    };
  }
  deleteChar(player: Player): Observable<Player> {
    const url = Globals.APP_API+ '/player/' + player.id;
    const httpOptions = {
      headers: new HttpHeaders({'Content-Type': 'application/json'})
    };
    return this.http.delete<Player>(url, httpOptions).pipe(
      tap(_ => this.log('deleted player id=${type.id}')),
      catchError(this.handleError<Player>('deletePlayer'))
    );
  }
}
