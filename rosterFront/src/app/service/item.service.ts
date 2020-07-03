import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Item} from "../class/item";
import {Globals} from "../globals";

@Injectable({
  providedIn: 'root'
})
export class ItemService {

  constructor(public http: HttpClient) { }
  getItems():Observable<Item[]>{
    return this.http.get<Item[]>(Globals.APP_API+ '/item');
  }

}
