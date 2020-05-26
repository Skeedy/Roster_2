import { Component, OnInit } from '@angular/core';
import {RosterService} from '../../service/roster.service';
import {Roster} from '../../class/roster';
import {trigger,state,style,animate,transition} from '@angular/animations';
import {InstanceService} from "../../service/instance.service";
import {Raid} from "../../class/raid";
import {ItemService} from "../../service/item.service";
import {Item} from "../../class/item";
import {Router} from "@angular/router";

@Component({
  selector: 'app-roster',
  templateUrl: './roster.component.html',
  styleUrls: ['./roster.component.scss'],
})
export class RosterComponent implements OnInit {
public raids: Raid[];
  constructor(
    private instanceServ: InstanceService,
    private router: Router,
    private rosterServ: RosterService
  ) { }

  ngOnInit(): void {
    this.instanceServ.getInstances().subscribe((data) => {
      if (data) {
        this.raids = data;
        console.log(this.raids);
      }
    },(_)=>{
      this.router.navigate(['/']);
      this.rosterServ.logout();
    })
  }
}
