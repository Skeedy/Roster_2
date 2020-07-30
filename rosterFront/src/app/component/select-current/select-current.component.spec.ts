import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SelectCurrentComponent } from './select-current.component';

describe('SelectCurrentComponent', () => {
  let component: SelectCurrentComponent;
  let fixture: ComponentFixture<SelectCurrentComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SelectCurrentComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SelectCurrentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
