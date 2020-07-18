import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {animate, style, transition, trigger} from "@angular/animations";
import {Item} from "../../class/item";
import {Player} from "../../class/player";

@Component({
  selector: 'app-pool',
  templateUrl: './pool.component.html',
  styleUrls: ['./pool.component.scss'],
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
export class PoolComponent implements OnInit {
  @Input() idRaid: number;
  @Input() nameRaid: string;
  @Input() poolList: boolean;
  @Input() numberChest: number;
  @Input() itemRaid: Item;
  @Input() players: Player[];
  @Output() poolListChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor() { }

  ngOnInit(): void {

  }
  close() {
    this.poolList = false;
    this.poolListChange.emit(this.poolList);
  }
}
