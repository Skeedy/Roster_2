import { Injectable } from '@angular/core';
import {Error} from '../class/error';

@Injectable({
  providedIn: 'root'
})
export class ErrorService {
public error = new Error();
  constructor() { }

  getError(html, subhtml = ''){
    this.error.isError = true;
    this.error.html = html;
    this.error.subhtml = subhtml? subhtml : '';
  }
  validateError(){
    this.error.html= '';
    this.error.isError = false;
  }
}
