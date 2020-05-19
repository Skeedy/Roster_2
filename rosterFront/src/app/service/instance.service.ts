import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";
import {Observable} from "rxjs";
import {Raid} from "../class/raid";

@Injectable({
  providedIn: 'root'
})
export class InstanceService {

  constructor(private http: HttpClient) { }
  getInstances(): Observable<Raid[]>{
    return this.http.get<Raid[]>(Globals.APP_API+ '/instance')
  }
}
