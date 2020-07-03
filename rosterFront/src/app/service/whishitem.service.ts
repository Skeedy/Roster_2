import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";
import {BehaviorSubject, Observable} from "rxjs";
import {Wishitem} from "../class/wishitem";
import {Roster} from "../class/roster";
import {map} from "rxjs/operators";

@Injectable({
  providedIn: 'root'
})
export class WhishitemService {
  public _wishItemSub = new BehaviorSubject<Wishitem>(new Wishitem());
  public _wishItem: Observable<Wishitem>;
  constructor(private http: HttpClient) { }

  public getWishItem(wishId): Observable<Wishitem>{
    return this.http.get<Wishitem>(Globals.APP_API +'/wishitem/'+ wishId).pipe(map((data) => {
      if (data ) {
        this._wishItem = this._wishItemSub.asObservable();
        this._wishItemSub.next(data);
      }
      return data;
    }));
  }
  changeGear(itemId, wishId){
    const obj ={
      itemId: itemId
    }
    return this.http.patch(Globals.APP_API + '/wishitem/' + wishId, obj);
  }
  public refreshWishItem(wishId){
    return this.http.get<Wishitem>(Globals.APP_API +'/wishitem/'+ wishId).pipe(map((data) => {
      if (data) {
        this._wishItemSub.next(data);
      }
      console.log(this._wishItem);
      return data;
    }));
  }
}
