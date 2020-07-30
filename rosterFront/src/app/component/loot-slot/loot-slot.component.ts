import {Component, Input, OnInit} from '@angular/core';
import {Loot} from "../../class/loot";
import {Raid} from "../../class/raid";
import {RosterService} from "../../service/roster.service";
import {Player} from "../../class/player";

@Component({
  selector: 'app-loot-slot',
  templateUrl: './loot-slot.component.html',
  styleUrls: ['./loot-slot.component.scss']
})
export class LootSlotComponent implements OnInit {
@Input() lootSlot: any;
@Input() chest: number;
@Input() raid: Raid;
  lootId: number|null;
  showPool = false;
  constructor(public rosterServ: RosterService) { }

  ngOnInit(): void {
  }

}
