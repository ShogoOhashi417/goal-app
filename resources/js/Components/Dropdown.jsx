import { useState, createContext, useContext, Fragment } from "react";
import { Link } from "@inertiajs/react";
import { Transition } from "@headlessui/react";

const DropdownContext = createContext();

DropdownContext.displayName = "DropdownContext";

const Dropdown = ({ children }) => {
    const [open, setOpen] = useState(false);

    const toggleOpen = () => {
        setOpen((previousState) => !previousState);
    };

    return (
        <DropdownContext.Provider value={{ open, setOpen, toggleOpen }}>
            <div className="relative">{children}</div>
        </DropdownContext.Provider>
    );
};

const Trigger = ({ children }) => {
    const { open, setOpen, toggleOpen } = useContext(DropdownContext);

    return (
        <>
            <div onClick={toggleOpen}>{children}</div>

            {open && (
                <div
                    className="fixed inset-0 z-40"
                    onClick={() => setOpen(false)}
                ></div>
            )}
        </>
    );
};

const Content = ({
    align = "right",
    width = "48",
    contentClasses = "py-1 bg-white",
    children,
}) => {
    const { open, setOpen } = useContext(DropdownContext);

    let alignmentClasses = "origin-top";

    if (align === "left") {
        alignmentClasses = "origin-top-left left-0";
    } else if (align === "right") {
        alignmentClasses = "origin-top-right right-0";
    }

    let widthClasses = "";

    if (width === "48") {
        widthClasses = "w-48";
    }

    return (
        <>
            <Transition
                as={Fragment}
                show={open}
                enter="transition ease-out duration-200"
                enterFrom="opacity-0 scale-95"
                enterTo="opacity-100 scale-100"
                leave="transition ease-in duration-75"
                leaveFrom="opacity-100 scale-100"
                leaveTo="opacity-0 scale-95"
            >
                <div
                    className={`absolute mt-1 ${alignmentClasses} ${widthClasses} rounded-md shadow-lg z-50`}
                    style={{ top: "100%" }}
                    onClick={() => setOpen(false)}
                >
                    <div
                        className={
                            `rounded-md ring-1 ring-black ring-opacity-5 ` +
                            contentClasses
                        }
                    >
                        {children}
                    </div>
                </div>
            </Transition>
        </>
    );
};

const DropdownLink = ({
    className = "",
    children,
    active = false,
    ...props
}) => {
    return (
        <Link
            {...props}
            className={
                "block w-full px-4 py-2 text-start text-sm leading-5 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out " +
                (active ? "text-gray-900 bg-gray-50 " : "text-gray-700 ") +
                className
            }
        >
            {children}
        </Link>
    );
};

Dropdown.Trigger = Trigger;
Dropdown.Content = Content;
Dropdown.Link = DropdownLink;

export default Dropdown;
