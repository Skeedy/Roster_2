import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {PlayerJob} from "../../class/player-job";

@Component({
  selector: 'app-player-job-loot',
  templateUrl: './player-job-loot.component.html',
  styleUrls: ['./player-job-loot.component.scss']
})
export class PlayerJobLootComponent implements OnInit {

  constructor() { }
  @Input() playerJob: PlayerJob;
  @Input() lootSlot: any;
  @Input() playerJobSet: number;
  public playerJobSelectedId : number;
  @Input() playerJobSel :number;
  @Output() playerJobSelected: EventEmitter<number>= new EventEmitter<number>();
  ngOnInit(): void {
  }
  setPlayerJob(idPlayerJob){
    this.playerJobSelectedId = idPlayerJob;
    this.playerJobSelected.emit(idPlayerJob);
  }
}
