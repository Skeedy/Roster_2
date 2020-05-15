import { Injectable } from '@angular/core';
import {BehaviorSubject, Observable} from "rxjs";
import {Job} from "../class/job";
import {HttpClient} from "@angular/common/http";
import {Globals} from "../globals";

@Injectable({
  providedIn: 'root'
})
export class JobService {
  public _jobSub = new BehaviorSubject<Job>(new Job());
  public _job: Observable<Job>;
  constructor(private http: HttpClient) { }
  getJobs(){
    return this.http.get<Job>(Globals.APP_API+ '/job/').subscribe((data: Job) => {
      if (data) {
        this._job = this._jobSub.asObservable();
        this._jobSub.next(data);
      }
      console.log(data)
    })
  }
}
