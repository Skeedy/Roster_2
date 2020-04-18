import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Globals} from '../globals';
import {catchError, tap} from 'rxjs/operators';
import {Observable, of} from 'rxjs';
import {Roster} from '../class/roster';

@Injectable({
  providedIn: 'root'
})
export class RosterService {

  constructor(private http: HttpClient) { }
  url= Globals.APP_API +'/roster';
  public getRosters() {
    return this.http.get<Roster[]>(`${this.url}`);
  }
}
