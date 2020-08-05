import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {RosterService} from "../../service/roster.service";
import {animate, style, transition, trigger} from "@angular/animations";
import {Item} from "../../class/item";
import {LootService} from "../../service/loot.service";
import {PlayerJob} from "../../class/player-job";

@Component({
  selector: 'app-set-upgrade',
  templateUrl: './set-upgrade.component.html',
  styleUrls: ['./set-upgrade.component.scss'],
  animations: [
    trigger('pool', [
      transition('void => *', [
        style({ transform: 'scale3d(.3, .3, .3)' }),
        animate(100)
      ]),
      transition('* => void', [
        animate(100, style({ transform: 'scale3d(.0, .0, .0)' }))
      ])
    ])
  ]
})
export class SetUpgradeComponent implements OnInit {
  @Input() setUpgrade;
  @Input() item: Item;
  @Input() valueRaid: number;
  playerJob: PlayerJob;
  stuffToUpgrade: Item[];
  playerJobSelectedId: number;
  itemId: number;
  @Output() setUpgradeChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(public rosterServ : RosterService, public lootServ : LootService) { }

  ngOnInit(): void {
  }
  close() {
    this.setUpgrade = false;
    this.setUpgradeChange.emit(this.setUpgrade);
  }
  getStuff($event, playerJob){
    this.stuffToUpgrade = $event;
    this.playerJob = playerJob;
    this.playerJobSelectedId = playerJob.id;
    this.itemId = null;
  }
  getItem($event){
    this.itemId = $event;
  }
}
