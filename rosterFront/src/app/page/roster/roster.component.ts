import { Component, OnInit } from '@angular/core';
import {RosterService} from '../../service/roster.service';
import {Roster} from '../../class/roster';
import {trigger,state,style,animate,transition} from '@angular/animations';

@Component({
  selector: 'app-roster',
  templateUrl: './roster.component.html',
  styleUrls: ['./roster.component.scss'],
})
export class RosterComponent implements OnInit {
  rosters : Roster[];
  constructor(
    private rosterService: RosterService
  ) { }

  ngOnInit(): void {

  }

}
