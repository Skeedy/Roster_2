import { Component, OnInit } from '@angular/core';
import {Roster} from "../../class/roster";
import {RosterService} from "../../service/roster.service";
import {animate, state, style, transition, trigger} from "@angular/animations";
import {Router} from "@angular/router";

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
  logIsOpen = false;
  registerOpen = false;
  rosters : Roster[];
  toggleLogIn() {
    this.logIsOpen = !this.logIsOpen;
  }
  toggleRegister() {
    this.registerOpen = !this.registerOpen;
  }
  constructor(
    private rosterService: RosterService,
    private router: Router
  ) { }

  ngOnInit(): void {
    if (this.rosterService.isConnected()){
      this.router.navigate(['/roster']);
    }
  }
}
