import {Component, Input, OnInit} from '@angular/core';
import {RosterService} from '../../service/roster.service';
import {InstanceService} from "../../service/instance.service";
import {Raid} from "../../class/raid";
import {Router} from "@angular/router";
import {LootService} from "../../service/loot.service";
import {Loot} from "../../class/loot";

@Component({
  selector: 'app-roster',
  templateUrl: './roster.component.html',
  styleUrls: ['./roster.component.scss'],
})
export class RosterComponent implements OnInit {
  public raids: Raid[];
  public players: any;
  public week: any;
  public loots: Loot[];
  constructor(
    private instanceServ: InstanceService,
    private router: Router,
    public rosterServ: RosterService,
    public lootService: LootService,
  ) { }

  ngOnInit(): void {
    this.rosterServ.refreshRoster().subscribe();
    if(!this.loots) {
      this.lootService.getWeekLoot().subscribe((data) => {
        this.loots = data;
      });
    }
    if (this.loots){
      this.lootService.refreshWeekLoot().subscribe((data) => {
        this.loots = data;
      });
    }
    this.lootService.getWeek().subscribe(data=>
      this.week = data);
    this.instanceServ.getInstances().subscribe((data) => {
      if (data) {
        this.raids = data;
      }
    },(_)=>{
      this.router.navigate(['/']);
      this.rosterServ.logout();
    });

  }

  // getAugment(instanceId){
  //   return this.raids.filter((raid: Raid)=>{
  //     return raid.id === instanceId
  //   }).find((item: Item)=>{
  //     return item.name === "Crystalline Twine"
  //   })
  // }
}
