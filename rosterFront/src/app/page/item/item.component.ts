import { Component, OnInit } from '@angular/core';
import {RosterService} from "../../service/roster.service";

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.scss']
})
export class ItemComponent implements OnInit {

  constructor(public rosterServ: RosterService) { }

  ngOnInit(): void {
    this.rosterServ.getRosters();
  }

}
