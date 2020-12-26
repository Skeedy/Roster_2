import {Component, Input, OnInit} from '@angular/core';
import {Item} from "../../class/item";
import {Raid} from "../../class/raid";

@Component({
  selector: 'app-upgrade',
  templateUrl: './upgrade.component.html',
  styleUrls: ['./upgrade.component.scss']
})
export class UpgradeComponent implements OnInit {
@Input() item: Item;
@Input() lootSlot: any;
@Input() raid: Raid;
  showSetUpgrade = false;
  constructor() { }

  ngOnInit(): void {
  }

}
