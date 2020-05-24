import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Globals} from '../globals';
import {catchError, delay, map, tap} from 'rxjs/operators';
import {BehaviorSubject, Observable, of} from 'rxjs';
import {Roster} from '../class/roster';
import {PlayerListService} from "./player-list.service";

@Injectable({
  providedIn: 'root'
})
export class RosterService {
  public _rosterSub = new BehaviorSubject<Roster>(new Roster());
  public _roster: Observable<Roster>;
  public nbPlayer: number;
  public rosterID: number;
  constructor(private http: HttpClient, private searchServ: PlayerListService) { }
  url= Globals.APP_API +'/roster/27';

  public getRosters() {
    return this.http.get<Roster>(`${this.url}`).subscribe((data: Roster) => {
      if (data) {
        this._roster = this._rosterSub.asObservable();
        this._rosterSub.next(data);
        this.nbPlayer = this._rosterSub.value.player.length;
        this.rosterID = this._rosterSub.value.id;
        if (this.nbPlayer < 8) {
          this.searchServ.formUp = true;
          this.searchServ.nbForm = 1;
        }
      }
    });
  }
  postPlayer(){
    this.searchServ.playerList.rosterID = this.rosterID;
    return this.http.post(Globals.APP_API + '/player/new', this.searchServ.playerList);
  }
  patchJob(bool, job, player, ddbId, order){
    const obj ={
      ddbId: ddbId,
      job: job,
      isMain: !bool,
      isSub: bool,
      ord: !bool ? 1 : order
    }
    return this.http.patch(Globals.APP_API + '/player/patch/'+ player, obj);
  }
  deleteJob(id){
    return this.http.delete( Globals.APP_API + '/playerjob/'+ id);
  }
  public register(data) {
    const obj = {
      rostername: data.rostername,
      email: data.email,
      password: data.password
    };
    return this.http.post(Globals.APP_API + '/roster/new', obj);
  }
}
