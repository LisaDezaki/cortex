import Input			from '@/Components/UI/Input/Input.svelte';
import InputCheckbox	from '@/Components/UI/Input/Checkbox.svelte';
import InputNumber		from '@/Components/UI/Input/Number.svelte';
import InputOption		from '@/Components/UI/Input/Option.svelte';
import InputRadio		from '@/Components/UI/Input/Radio.svelte';
import InputSelect		from '@/Components/UI/Input/Select.svelte';
import InputSlider		from '@/Components/UI/Input/Slider.svelte';
import InputSwitch		from '@/Components/UI/Input/Switch.svelte';
import InputText		from '@/Components/UI/Input/Text.svelte';
import InputTextarea	from '@/Components/UI/Input/Textarea.svelte';
import InputUpload		from '@/Components/UI/Input/Upload.svelte';

Input.Checkbox	= InputCheckbox;
Input.Number	= InputNumber;
Input.Option	= InputOption;
Input.Radio		= InputRadio;
Input.Select	= InputSelect;
Input.Slider	= InputSlider;
Input.Switch	= InputSwitch;
Input.Text		= InputText;
Input.Textarea	= InputTextarea;
Input.Upload	= InputUpload;

export default Input;