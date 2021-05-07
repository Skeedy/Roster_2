import {Component, Input, OnChanges, OnInit} from '@angular/core';
import {LootService} from "../../service/loot.service";
import {Loot} from "../../class/loot";

@Component({
  selector: 'app-previous-loot',
  templateUrl: './previous-loot.component.html',
  styleUrls: ['./previous-loot.component.scss']
})
export class PreviousLootComponent implements OnChanges {
@Input() week: any;
public loots : Loot[];
  panelOpenState = false;
  constructor(public lootServ : LootService) { }

  ngOnChanges(): void {

  }
  getWeekLoot(value){
    this.lootServ.getLootByWeek(value).subscribe((data)=>{
      this.loots = data;
      this.panelOpenState = true;
    })
  }
}
