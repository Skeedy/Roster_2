import { Component, OnInit } from '@angular/core';
import {RosterService} from '../../service/roster.service';
import {Roster} from '../../class/roster';
import {trigger,state,style,animate,transition} from '@angular/animations';

@Component({
  selector: 'app-roster',
  templateUrl: './roster.component.html',
  styleUrls: ['./roster.component.scss'],
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
export class RosterComponent implements OnInit {
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
    private rosterService: RosterService
  ) { }

  ngOnInit(): void {
    this.getRosters();
  }
  getRosters(){
    this.rosterService.getRosters().subscribe((data: any) => {this.rosters = data;});
  }
}
