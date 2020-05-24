import {AfterViewInit, Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {Item} from "../../class/item";
import {animate, style, transition, trigger} from "@angular/animations";
import {PlayerJob} from "../../class/player-job";
import {ItemService} from "../../service/item.service";
import {RosterService} from "../../service/roster.service";

@Component({
  selector: 'app-select-gear',
  templateUrl: './select-gear.component.html',
  styleUrls: ['./select-gear.component.scss'],
  animations: [
    trigger('gearShow', [
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
export class SelectGearComponent implements OnChanges {
  @Input() jobItems: Item[];
  @Input() slotId: number;
  @Input() closable = true;
  @Input() gearShow: boolean;
  @Input() playerJobId : number;
  @Output() gearShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(private itemServ: ItemService, public rosterServ: RosterService) { }

  ngOnChanges(): void {
  }
  changeGear(itemId, playerJobId, slotId){
    return this.itemServ.changeGear(itemId, playerJobId, slotId).subscribe(_=>
    this.rosterServ.getRosters())
  }
  close() {
    this.gearShow = false;
    this.gearShowChange.emit(this.gearShow);
  }
}
