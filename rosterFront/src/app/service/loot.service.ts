import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";
import {BehaviorSubject, Observable} from "rxjs";
import {Job} from "../class/job";
import {Loot} from "../class/loot";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class LootService {
  public _lootSub = new BehaviorSubject<Loot>(new Loot());
  public _loot: Observable<Loot>;

  constructor(private http: HttpClient) { }
  getWeekLoot():Observable<Loot>{
    return this.http.get<Loot>(Globals.APP_API+ '/roster/currentWeek').pipe(map((data) => {
      if (data) {
        this._loot = this._lootSub.asObservable();
        this._lootSub.next(data);
      }
      return data;
    }));
  }
}
