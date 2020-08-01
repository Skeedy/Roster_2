import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {PlayerJob} from "../../class/player-job";
import {Item} from "../../class/item";

@Component({
  selector: 'app-player-job-loot',
  templateUrl: './player-job-loot.component.html',
  styleUrls: ['./player-job-loot.component.scss']
})
export class PlayerJobLootComponent implements OnInit, OnChanges {

  constructor() { }
  @Input() playerJob: PlayerJob;
  @Input() lootSlot: any;
  @Input() playerJobSet: number;
  public playerJobSelectedId : number;
  @Input() playerJobSel :number;
  @Input() slotItemid: number;
  @Input() item: Item;
  disabled :boolean;
  noNeed = true;
  @Output() playerJobSelected: EventEmitter<number>= new EventEmitter<number>();
  ngOnInit(){
    this.noNeed = true;
  }
  ngOnChanges(): void {
    this.disabled = false;
    this.noNeed = false;
    this.check();
  }
  setPlayerJob(idPlayerJob){
    this.playerJobSelectedId = idPlayerJob;
    this.playerJobSelected.emit(idPlayerJob);
  }
  check(){
    if(this.item) {
      let slotName = this.item.slot.name;
      if (this.item.isSavage) {
        if(this.item.isCoffer) {
          if(this.item.slot.id === 1){
            if(this.playerJob.currentstuff.mainHand) {
              if (this.item.slot.id === this.playerJob.currentstuff.mainHand.slot.id && this.playerJob.currentstuff.mainHand.isSavage) {
                return this.disabled = true;
              }
            }
            if (!this.playerJob.wishitem[slotName]) {
              return this.noNeed = true;
            }
            if(this.item.slot.id !== this.playerJob.wishitem.mainHand.slot.id){
              return this.noNeed = true;
            }
          }
          else {
            if (this.playerJob.currentstuff[slotName] && this.playerJob.currentstuff[slotName].slot.id === this.item.slot.id) {
              return this.disabled = true;
            }
            if (!this.playerJob.wishitem[slotName] || !this.playerJob.wishitem[slotName].isSavage) {
              return this.noNeed = true;
            }
            if (this.playerJob.wishitem[slotName].slot.id !== this.item.slot.id) {
              return this.noNeed = true;
            }
          }
        }
        else{
          if (this.playerJob.currentstuff[slotName] && this.playerJob.currentstuff[slotName] && this.playerJob.currentstuff[slotName].id === this.item.id) {
            return this.disabled = true;
          }
          if (!this.playerJob.wishitem[slotName]){
            return this.noNeed = true;
          }
          if (this.playerJob.wishitem[slotName].id !== this.item.id) {
            return this.noNeed = true;
          }
        }
      }
    }
  }
}
