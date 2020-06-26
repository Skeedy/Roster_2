import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";
import {Observable} from "rxjs";
import {Wishitem} from "../class/wishitem";

@Injectable({
  providedIn: 'root'
})
export class WhishitemService {

  constructor(private http: HttpClient) { }

  public getWishItem(playerJobId): Observable<Wishitem>{
    return this.http.get<Wishitem>(Globals.APP_API +'/wishitem/'+ playerJobId);
  }
}
