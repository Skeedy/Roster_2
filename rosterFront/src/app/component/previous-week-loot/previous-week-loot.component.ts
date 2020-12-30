import {Component, Input, OnInit} from '@angular/core';
import {Loot} from "../../class/loot";

@Component({
  selector: 'app-previous-week-loot',
  templateUrl: './previous-week-loot.component.html',
  styleUrls: ['./previous-week-loot.component.scss']
})
export class PreviousWeekLootComponent implements OnInit {
@Input() loots: Loot[];
  constructor() { }

  ngOnInit(): void {
    console.log(this.loots)
  }

}
