import { Component, OnInit } from '@angular/core';
import {RosterService} from "../../service/roster.service";
import {Router} from "@angular/router";
import {LootService} from "../../service/loot.service";
import {Coffer} from "../../class/coffer";
import {Title} from "@angular/platform-browser";

@Component({
  selector: 'app-item',
  templateUrl: './item.component.html',
  styleUrls: ['./item.component.scss']
})
export class ItemComponent implements OnInit {
public coffers : Coffer[];
  constructor(private router: Router,
              public rosterServ: RosterService,
              public lootServ: LootService,
              private titleService: Title) { }

  ngOnInit(): void {
    this.titleService.setTitle('Items - FFXIVRoster')
      this.rosterServ.getRoster().subscribe(_ => {
        },
        _ => {
          this.router.navigate(['/']);
          this.rosterServ.logout()
        });
    if (this.lootServ.coffers.length === 0) {
      this.lootServ.getCoffers().subscribe(data => {
        this.coffers = data;
      })
    }
  }

}
