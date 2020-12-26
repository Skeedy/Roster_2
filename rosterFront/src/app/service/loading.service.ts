import { Injectable } from '@angular/core';
import {Loading} from '../class/loading';

@Injectable({
  providedIn: 'root'
})
export class LoadingService {
public loading = new Loading();
  constructor() { }
  activeLoading(){
    return this.loading.isActive = true;
  }
  removeLoading(){
    return this.loading.isActive = false;
  }
}
