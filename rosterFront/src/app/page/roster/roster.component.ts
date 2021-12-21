import {Component, Input, OnInit} from '@angular/core';
import {RosterService} from '../../service/roster.service';
import {InstanceService} from "../../service/instance.service";
import {Raid} from "../../class/raid";
import {Router} from "@angular/router";
import {LootService} from "../../service/loot.service";
import {Loot} from "../../class/loot";
import {Title} from "@angular/platform-browser";

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

  order = 'id';

  constructor(
    private instanceServ: InstanceService,
    private router: Router,
    public rosterServ: RosterService,
    public lootService: LootService,
    private titleService: Title
  ) { }

  ngOnInit(): void {
    this.titleService.setTitle('Instances - FFXIVRoster')
    this.rosterServ.refreshRoster().subscribe(() => {
        this.lootService.getWeeks().subscribe(data => {
          // @ts-ignore
          this.week = data.week;
          // @ts-ignore
          this.showPrevious = data.showPrevious;
          // @ts-ignore
          this.weekCount = this.showPrevious ? data.weekCount : [];
          this.instanceServ.getInstances().subscribe((data: Raid[]) => {
            if (data) {
              this.raids = data;
            }
          }, (_) => {
            this.router.navigate(['/']);
            this.rosterServ.logout();
          });
        })
      },
      (err) => {
        this.router.navigate(['/']);
        this.rosterServ.logout();
      });
    if (this.loots) {
      this.lootService.refreshWeekLoot().subscribe((data) => {
        this.loots = data;
      });
    }
    if (!this.loots) {
      this.lootService.getWeekLoot().subscribe((data) => {
        this.loots = data;
      });
    }
}

// getAugment(instanceId){
//   return this.raids.filter((raid: Raid)=>{
//     return raid.id === instanceId
//   }).find((item: Item)=>{
//     return item.name === "Crystalline Twine"
//   })
// }
}
