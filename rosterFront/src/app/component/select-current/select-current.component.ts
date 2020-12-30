import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Item} from "../../class/item";
import {Player} from "../../class/player";
import {CurrentstuffService} from "../../service/currentstuff.service";
import {animate, style, transition, trigger} from "@angular/animations";

@Component({
  selector: 'app-select-current',
  templateUrl: './select-current.component.html',
  styleUrls: ['./select-current.component.scss'],
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
export class SelectCurrentComponent implements OnInit {
  @Input() jobItems: Item[];
  @Input() slotId: number;
  @Input() closable = true;
  @Input() gearShow: boolean;
  @Input() currentId: number;
  @Input() slotName: string;
  public player : Player;
  @Output() gearShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  constructor(private currentServ: CurrentstuffService) { }

  ngOnInit(): void {
  }
  changeGear(itemId){
    return this.currentServ.changeGear(itemId, this.currentId).subscribe(data => {
      this.currentServ.refreshCurrentItem(this.currentId).subscribe();
      this.close();
    })
  }
  close() {
    this.gearShow = false;
    this.gearShowChange.emit(this.gearShow);
  }
}
