import {AfterViewInit, Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {Player} from "../../class/player";
import {animate, style, transition, trigger} from "@angular/animations";
import {JobService} from "../../service/job.service";
import {Item} from "../../class/item";
import {Observable} from "rxjs";

@Component({
  selector: 'app-player-show',
  templateUrl: './player-show.component.html',
  styleUrls: ['./player-show.component.scss'],
  animations: [
    trigger('playerShow', [
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
export class PlayerShowComponent implements OnChanges {
  @Input() player:Player;
  @Input() closable = true;
  @Input() playerShow: boolean;
  @Output() playerShowChange: EventEmitter<boolean> = new EventEmitter<boolean>();
  @Input() idMain : number;

  public items: Item[];
  constructor(public jobServ: JobService) { }

  ngOnChanges(): void {
     this.jobServ.getJobStuff(this.idMain).subscribe((data) =>{
       this.items= data;
        console.log(this.items);
     });
  }
  close() {
    this.playerShow = false;
    this.playerShowChange.emit(this.playerShow);
  }
}
