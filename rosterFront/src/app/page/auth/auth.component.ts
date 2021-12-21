import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Roster} from "../../class/roster";
import {RosterService} from "../../service/roster.service";
import {animate, state, style, transition, trigger} from "@angular/animations";
import {Router} from "@angular/router";
import {SoundService} from "../../service/sound.service";
import {CookieService} from "ngx-cookie-service";
import {Title} from "@angular/platform-browser";

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.scss'],
  animations: [
    trigger('logOpenClose', [
      state('open', style({
        height: '100%',
        opacity: 1,
        display : 'block'
      })),
      state('closed', style({
        height: '0px',
        opacity: 0,
      })),
      transition('open => closed', [
        animate('0.1s')
      ]),
      transition('closed => open', [
        animate('0.1s')
      ]),
    ]),
    trigger('registerOpenClose', [
      state('open', style({
        height: '100%',
        opacity: 1,
        display : 'block'
      })),
      state('closed', style({
        height: '0px',
        opacity: 0,
      })),
      transition('open => closed', [
        animate('0.1s')
      ]),
      transition('closed => open', [
        animate('0.1s')
      ]),
    ]),
  ],
})
export class AuthComponent implements OnInit {
  logIsOpen = true;
  registerOpen = false;
  rosters : Roster[];
  isVisible= true;

  constructor(
    private rosterService: RosterService,
    private router: Router,
    public sound: SoundService,
    public cookieServ : CookieService,
    private titleService: Title
  ) { }

  ngOnInit(): void {
    this.titleService.setTitle('Welcome - FFXIVRoster')
    if (this.rosterService.isConnected()){
      this.router.navigate(['/roster']);
    }
  }
  toggleLogIn() {
    // this.sound.playAction();
    this.logIsOpen = !this.logIsOpen;
  }
  toggleRegister() {
    // this.sound.playAction();
    this.registerOpen = !this.registerOpen;
  }
}
