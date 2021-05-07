import {Component, Input, OnChanges, OnInit} from '@angular/core';
import {Loot} from "../../class/loot";
import {LootService} from "../../service/loot.service";

@Component({
  selector: 'app-previous-week-loot',
  templateUrl: './previous-week-loot.component.html',
  styleUrls: ['./previous-week-loot.component.scss']
})
export class PreviousWeekLootComponent implements OnChanges {
@Input() loots: Loot[];
  constructor(public lootServ : LootService) { }

  ngOnChanges(): void {
  }
}
