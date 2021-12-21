import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Globals} from '../globals';
import {catchError, delay, map, tap} from 'rxjs/operators';
import {BehaviorSubject, Observable, of} from 'rxjs';
import {Roster} from '../class/roster';
import {PlayerListService} from "./player-list.service";
import {Login} from "../class/login";
import {Router} from "@angular/router";

@Injectable({
  providedIn: 'root'
})
export class RosterService {
  public _rosterSub = new BehaviorSubject<Roster>(new Roster());
  public _roster: Observable<Roster>;
  private loginSubject: BehaviorSubject<Login>;
  private loginObs: Observable<Login>;
  public nbPlayer: number;
  public rosterID: number;
  constructor(private http: HttpClient, private searchServ: PlayerListService, private router: Router) {
    const token = JSON.parse(localStorage.getItem(Globals.APP_USER_TOKEN));
    this.loginSubject = new BehaviorSubject<Login>(token);
    this.loginObs = this.loginSubject.asObservable();
  }

  public login(rostername: string, password: string) {
    return this.http.post<Login>(Globals.APP_API + '/login_check', { rostername, password })
      .pipe(map((data) => {
        if (data && data.token) {
          localStorage.setItem(Globals.APP_USER_TOKEN, JSON.stringify(data));
          this.loginSubject.next(data);
        }
        return data;
      }));
  }
  public getRoster() {
    return this.http.get<Roster>(Globals.APP_API + '/roster/profile').pipe(map((roster) => {
      if (roster) {
        localStorage.setItem(Globals.APP_USER, JSON.stringify(roster));
        this._roster = this._rosterSub.asObservable();
        this._rosterSub.next(roster);
        this.nbPlayer = this._rosterSub.value.player.length;
        this.rosterID = this._rosterSub.value.id;
      }
      return roster;
    }));
  }
  public refreshRoster() {
    return this.http.get<Roster>(Globals.APP_API + '/roster/profile').pipe(map((roster) => {
      if (roster) {
        this._rosterSub.next(roster);
      }
      return roster;
    }));
  }
  public isConnected(): boolean {
    return !!this.loginSubject.value && !!this._rosterSub.value;
  }

  public get tokenData() {
    return JSON.parse(localStorage.getItem(Globals.APP_USER_TOKEN));
  }

  postPlayer(){
    this.searchServ.playerList.rosterID = this.rosterID;
    return this.http.post(Globals.APP_API + '/player/new', this.searchServ.playerList);
  }

  public get currentUser(): Roster|null {
    return this._rosterSub.value;
  }

  public logout() {
    localStorage.removeItem(Globals.APP_USER_TOKEN);
    localStorage.removeItem(Globals.APP_USER);
    this.loginSubject.next(null);
    this._rosterSub.next(null);
    this.isConnected();
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
    return this.http.post(Globals.APP_API + '/roster/register', obj);
  }
  public deleteRoster(){
    return this.http.delete(Globals.APP_API+'/roster/')
  }
  public sendEmailPassword(email){
    const obj = {
      email: email
    }
    return this.http.post(Globals.APP_API + '/checkEmailPassword', obj);
  }
  public changePassword(data, token){
    const obj = {
      token : token,
      password: data.password
    }
      return this.http.post(Globals.APP_API + '/changePassword', obj);
    }
    public updateDatas(obj){
      return this.http.patch(Globals.APP_API + '/updateDatas', obj);
    }
}
