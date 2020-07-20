import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LootSlotComponent } from './loot-slot.component';

describe('LootSlotComponent', () => {
  let component: LootSlotComponent;
  let fixture: ComponentFixture<LootSlotComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LootSlotComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LootSlotComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
