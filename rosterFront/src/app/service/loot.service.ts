import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";
import {BehaviorSubject, Observable} from "rxjs";
import {Loot} from "../class/loot";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class LootService {

  constructor(private http: HttpClient) { }
  getWeekLoot():Observable<Loot[]>{
    return this.http.get<Loot[]>(Globals.APP_API+ '/roster/currentWeekLoot')
  }
  getWeek(){
    return this.http.get(Globals.APP_API+ '/roster/currentWeek')
  }
}
