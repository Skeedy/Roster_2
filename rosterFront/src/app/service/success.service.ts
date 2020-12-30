import { Injectable } from '@angular/core';
import {Success} from "../class/success";

@Injectable({
  providedIn: 'root'
})
export class SuccessService {
public success = new Success();
  constructor() { }
  getSuccess(html , subhtml = '') {
    this.success.html = html;
    this.success.isActive = true;
    this.success.subhtml = subhtml ? subhtml : '';
    setTimeout( ()=> {
        this.success.isActive = false
        this.success.html = ''
        this.success.subhtml = '';
      }
    ,3000)
  }
}
