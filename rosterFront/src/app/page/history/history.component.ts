import { Component, OnInit } from '@angular/core';
import {LootService} from "../../service/loot.service";
import {Title} from "@angular/platform-browser";

@Component({
  selector: 'app-history',
  templateUrl: './history.component.html',
  styleUrls: ['./history.component.scss']
})
export class HistoryComponent implements OnInit {
  public showPrevious: boolean;
  public weekCount: any;
  constructor(public lootService: LootService,
              private titleService: Title) { }

  ngOnInit(): void {
    this.titleService.setTitle('History - FFXIVRoster')
    this.lootService.getWeeks().subscribe(data=> {
      // @ts-ignore
      this.week = data.week;
      // @ts-ignore
      this.showPrevious = data.showPrevious;
      // @ts-ignore
      this.weekCount = this.showPrevious? data.weekCount : [];
  })
  }
}
