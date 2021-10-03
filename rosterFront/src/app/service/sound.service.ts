import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class SoundService {
  public audio = new Audio();
  constructor() { }


  playAction(){
    this.audio.src = '../assets/sounds/FFXIV_Confirm.mp3';
    this.audio.volume = 0.1;
    this.audio.load();
    this.audio.play();
  }
  playInput(){
    this.audio.src = '../assets/sounds/FFXIV_Enter_Chat.mp3';
    this.audio.volume = 0.1;
    this.audio.load();
    this.audio.play();
  }
  playError(){
    this.audio.src = '../assets/sounds/FFXIV_Error.mp3';
    this.audio.volume = 0.1;
    this.audio.load();
    this.audio.play();
  }
  playEnter(){
    this.audio.src = '../assets/sounds/FFXIV_Start_Game.mp3';
    this.audio.volume = 0.1;
    this.audio.load();
    this.audio.play();
  }
  playLogOut(){
    this.audio.src = '../assets/sounds/FFXIV_Log_Out.mp3';
    this.audio.volume = 0.1;
    this.audio.load();
    this.audio.play();
  }
}
