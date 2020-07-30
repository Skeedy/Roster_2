import { Injectable } from '@angular/core';
import {BehaviorSubject, Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";
import {map} from "rxjs/operators";
import {Currentstuff} from "../class/currentstuff";

@Injectable({
  providedIn: 'root'
})
export class CurrentstuffService {
  public _currentSub = new BehaviorSubject<Currentstuff>(new Currentstuff());
  public _current: Observable<Currentstuff>;
  constructor(private http: HttpClient) { }

  public getCurrentItem(wishId): Observable<Currentstuff>{
    return this.http.get<Currentstuff>(Globals.APP_API +'/currentstuff/'+ wishId).pipe(map((data) => {
      if (data ) {
        this._current = this._currentSub.asObservable();
        this._currentSub.next(data);
      }
      return data;
    }));
  }
  changeGear(itemId, stuffId){
    const obj ={
      itemId: itemId
    }
    return this.http.patch(Globals.APP_API + '/currentstuff/' + stuffId, obj)
  }
  public refreshCurrentItem(stuffId){
    return this.http.get<Currentstuff>(Globals.APP_API +'/currentstuff/'+ stuffId).pipe(map((data) => {
      if (data) {
        this._currentSub.next(data);
      }
      console.log(this._current);
      return data;
    }));
  }
}
