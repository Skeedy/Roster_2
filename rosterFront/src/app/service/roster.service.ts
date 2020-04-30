import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Globals} from '../globals';
import {catchError, tap} from 'rxjs/operators';
import {BehaviorSubject, Observable, of} from 'rxjs';
import {Roster} from '../class/roster';

@Injectable({
  providedIn: 'root'
})
export class RosterService {

  response: any = {};
  private messageResponse = new BehaviorSubject(this.response);
  currentResponse = this.messageResponse.asObservable();

  constructor(private http: HttpClient) { }
  url= Globals.APP_API +'/roster/27';
  public getRosters():Observable<any> {
    return this.http.get<Roster[]>(`${this.url}`);
  }
  public fillRoster(){
    this.getRosters().subscribe(res => { this.messageResponse.next(res)})
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
