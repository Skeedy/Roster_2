import { Component, OnInit } from '@angular/core';
import {RosterService} from '../../service/roster.service';
import {Roster} from '../../class/roster';

@Component({
  selector: 'app-roster',
  templateUrl: './roster.component.html',
  styleUrls: ['./roster.component.scss']
})
export class RosterComponent implements OnInit {
  rosters : Roster[];
  constructor(
    private rosterService: RosterService
  ) { }

  ngOnInit(): void {
    this.getRosters();
    console.log(this.getRosters());
  }
getRosters(){
    this.rosterService.getRosters().subscribe((data: any) => {this.rosters = data;});
}
}
