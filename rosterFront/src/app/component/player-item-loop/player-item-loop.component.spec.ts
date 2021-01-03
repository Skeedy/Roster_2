import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PlayerItemLoopComponent } from './player-item-loop.component';

describe('PlayerItemLoopComponent', () => {
  let component: PlayerItemLoopComponent;
  let fixture: ComponentFixture<PlayerItemLoopComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PlayerItemLoopComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PlayerItemLoopComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
