import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Globals} from '../globals';
import {catchError, delay, map, tap} from 'rxjs/operators';
import {BehaviorSubject, Observable, of} from 'rxjs';
import {Roster} from '../class/roster';

@Injectable({
  providedIn: 'root'
})
export class RosterService {
  public _rosterSub = new BehaviorSubject<Roster>(new Roster());
  public _roster: Observable<Roster>;
  constructor(private http: HttpClient) { }
  url= Globals.APP_API +'/roster/27';

  public getRosters() {
    return this.http.get<Roster>(`${this.url}`).pipe(map((roster: Roster) => {
      if (roster) {
        this._roster = this._rosterSub.asObservable().pipe(delay(0));
        this._rosterSub.next(roster);
      }
      return this._rosterSub.value;
    }
    ));
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
